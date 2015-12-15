--------------------------------------------------------
--  Ref Constraints for Table EX_TOUR
--------------------------------------------------------

  ALTER TABLE "SYSTEM"."EX_TOUR" ADD CONSTRAINT "EX_TOUR_FK4" FOREIGN KEY ("PACKAGE_NO")
	  REFERENCES "SYSTEM"."PACKAGE" ("PACKAGE_NO") ENABLE;
