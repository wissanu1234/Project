--------------------------------------------------------
--  Ref Constraints for Table GUIDE
--------------------------------------------------------

  ALTER TABLE "SYSTEM"."GUIDE" ADD CONSTRAINT "GUIDE_FK1" FOREIGN KEY ("COMPANY_ID")
	  REFERENCES "SYSTEM"."COMPANY" ("ID") ON DELETE CASCADE ENABLE;
