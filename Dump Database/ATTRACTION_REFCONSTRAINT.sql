--------------------------------------------------------
--  Ref Constraints for Table ATTRACTION
--------------------------------------------------------

  ALTER TABLE "SYSTEM"."ATTRACTION" ADD CONSTRAINT "ATTRACTION_FK1" FOREIGN KEY ("PACKAGE_NO")
	  REFERENCES "SYSTEM"."PACKAGE" ("PACKAGE_NO") ON DELETE CASCADE ENABLE;
